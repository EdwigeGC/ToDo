<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use Doctrine\Persistence\ObjectManager;
use App\Repository\TaskRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class TaskController provides features to manage tasks
 */
class TaskController extends AbstractController
{
    /**
     * The function displays the list of all tasks to do
     *
     * @Route("/tasks", name="task_list")
     *
     * @param TaskRepository $repository
     * @return Response
     */
    public function listAction(TaskRepository $repository): Response
    {
        return $this->render('task/list.html.twig', ['tasks' => $repository->findAll()]);
    }

    /**
     * The function displays the list of all tasks done
     *
     * @Route("/tasks/completed", name="task_completed")
     *
     * @param TaskRepository $repository
     *
     * @return Response
     */
    public function listClosed(TaskRepository $repository)
    {
        return $this->render('task/listCompleted.html.twig', ['tasks' => $repository->findBy(['isDone'=>1])]);
    }

    /**
     * The function displays the form to create a task
     *
     * @Route("/tasks/create", name="task_create")
     *
     * @param Request $request
     * @param ObjectManager $manager
     *
     * @return RedirectResponse|Response
     */
    public function createAction(Request $request, ObjectManager $manager)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setUsers($this->getUser());

            $manager->persist($task);
            $manager->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * The function displays the form to edit a task
     *
     * @Route("/tasks/{slug}/edit", name="task_edit")
     *
     * @param Task $task
     * @param Request $request
     * @param ObjectManager $manager
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Task $task, Request $request, ObjectManager $manager)
    {
        $this->denyAccessUnlessGranted('TASK_EDIT', $task);
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($task);
            $manager->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }
        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * The function mark the task has done
     *
     * @Route("/tasks/{slug}/toggle", name="task_toggle")
     *
     * @param Task $task
     * @param ObjectManager $manager
     *
     * @return RedirectResponse
     */
    public function toggleTaskAction(Task $task, ObjectManager $manager)
    {
        $this->denyAccessUnlessGranted('TASK_EDIT', $task);
        $task->toggle(!$task->isDone());
        $manager->flush();

        $this->addFlash('success','La tâche ' .$task->getTitle(). ' a bien été marquée comme faite.');

        return $this->redirectToRoute('task_list');
    }

    /**
     * The function deletes a task if the user logged is also the author
     *
     * @Route("/tasks/{slug}/delete", name="task_delete")
     *
     * @param Task $task
     * @param ObjectManager $manager
     *
     * @return RedirectResponse
     */
    public function deleteTaskAction(Task $task, ObjectManager $manager)
    {
        $this->denyAccessUnlessGranted('TASK_DELETE', $task);
        $manager->remove($task);
        $manager->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
