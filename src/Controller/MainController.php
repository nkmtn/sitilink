<?php

namespace App\Controller;

use App\Entity\Schedule;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ScheduleRepository;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="app_main")
     */
    public function index(ScheduleRepository $repository): Response
    {
        return $this->render('Task5.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    private function getAll(ScheduleRepository $repository) : array {
        $rows = $repository->findAll();
        $arr = [];
        foreach ($rows as $row) {
            $arr[] = [
                "id" => $row->getId(),
                "name" => $row->getName(),
                "points" => $row->getPoints()
            ];
        }
        return $arr;
    }


    public function getSchedule(ScheduleRepository $repository): JsonResponse {
        return new JsonResponse($this->getAll($repository), JsonResponse::HTTP_OK);
    }

    public function postSchedule(
        Request $request,
        ScheduleRepository $repository
    ) {
        if (!$request->getContent()) {
            return new JsonResponse('Empty form', JsonResponse::HTTP_BAD_REQUEST);
        }

        $message = $request->request->get('membersInput');
        $message = str_replace(' ', '', $message);
        $members = explode(',', $message);
        foreach ($members as $member) {
            if(preg_match('/[А-Яа-яЁё]+/', $member)) {
                $entity = (new Schedule())->setName($member);
                $entity->setPoints();
                $repository->add($entity);
            }
        }

        return new JsonResponse($this->getAll($repository), JsonResponse::HTTP_OK);
    }
}
