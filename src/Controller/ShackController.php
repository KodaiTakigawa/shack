<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Hack;

class ShackController extends Controller
{
    /**
     * @Route("/shack", name="index")
     */
    public function index()
    {
        return $this->render('shack/home.html.twig');
    }

    /**
     * @Route("/shack/result", name="result")
     */
    public function result(Request $request){
        $keyword = urlencode($request->query->get('search'));
 //       $request_url = "http://www.sysbird.jp/webapi/?apikey=guest&keyword=%E3%82%AB%E3%83%AC%E3%83%BC&max=10&order=r";
        $request_url = "http://www.sysbird.jp/toriko/api/?apikey=guest&format=json&keyword=${keyword}&max=10";

        $json = json_decode(file_get_contents($request_url));
        if($json->count == 0){
            $request_url = "http://www.sysbird.jp/toriko/api/?apikey=guest&format=json&max=10";
            $json = json_decode(file_get_contents($request_url));
        }
        $snacks = $json->item;
        return $this->render('shack/result.html.twig', ['snacks' => $snacks]);
    }

    /**
     * @Route("/shack/result/hack_list/{snack_id}", name="hack_list")
     */
    public function hack_list(Request $request, $snack_id){
        $snack_name = $request->query->get('snack_name');
        $hack_repository = $this->getDoctrine()->getRepository(Hack::class);
        $hack_list = $hack_repository->findBy(
            ['snack_id' => $snack_id]
        );
        return $this->render('shack/hack_list.html.twig', ['snack_name' => $snack_name, 'hack_list' => $hack_list, 'snack_id' => $snack_id]);
    }

    /**
     * @Route("/shack/result/hack_list/{snack_id}/detail/{hack_id}", name="hack_detail")
     */
    public function hack_detail(Request $request, $hack_id){
        $hack_repository = $this->getDoctrine()->getRepository(Hack::class);
        $hack = $hack_repository->find($hack_id);
        return $this->render('shack/hack_detail.html.twig', ['hack' => $hack]);
    }

    /**
     * @Route("/shack/result/hack_list/{snack_id}/add", name="add_hack", methods="GET")
     */
    public function add_hack(Request $request, $snack_id){
        return $this->render('shack/add_hack.html.twig');
    }

    /**
     * @Route("/shack/result/hack_list/{snack_id}/add", name="create_hack", methods="POST")
     * 
     */
    public function create_hack(Request $request, $snack_id){
        $em =  $this->getDoctrine()->getManager();
        $hack = new Hack();
        $hack->setTitle($request->request->get('title'));
        $hack->setMaterials($request->request->get('materials'));
        $hack->setDetail($request->request->get('detail'));
        $hack->setSnackId($snack_id);
        $em->persist($hack);
        $em->flush();

        return $this->redirect($this->generateUrl('hack_list', ['snack_id' => $snack_id]));
    }

    /**
     * @Route("/shack/result/hack_list/{snack_id}/detail/{hack_id}/edit", name="edit_hack", methods="GET")
     */
    public function edit_hack(Request $request, $hack_id){
        $em = $this->getDoctrine()->getManager();
        $hack = $em->getRepository(Hack::class)->find($hack_id);
        return $this->render('shack/edit_hack.html.twig', ['hack' => $hack]);
    }

    /**
     * @Route("/shack/result/hack_list/{snack_id}/detail/{hack_id}/edit", name="update_hack", methods="POST")
     * 
     */
    public function update_hack(Request $request, $snack_id, $hack_id){
        $em = $this->getDoctrine()->getManager();
        $hack = $em->getRepository(Hack::class)->find($hack_id);
        $hack->setTitle($request->request->get('title'));
        $hack->setMaterials($request->request->get('materials'));
        $hack->setDetail($request->request->get('detail'));
        $hack->setSnackId($snack_id);
        $em->flush();
        return $this->redirect($this->generateUrl('hack_detail', ['snack_id' => $snack_id, 'hack_id' => $hack_id]));
    }

    /**
     * @Route("/shack/result/hack_list/{snack_id}/detail/{hack_id}/delete", name="delete_hack")
     * 
     */
    public function delete_hack(Request $request, $snack_id, $hack_id){
        $em = $this->getDoctrine()->getManager();
        $hack = $em->getRepository(Hack::class)->find($hack_id);
        $em->remove($hack);
        $em->flush();
        return $this->redirect($this->generateUrl('hack_list', ['snack_id' => $snack_id]));
    }
}
