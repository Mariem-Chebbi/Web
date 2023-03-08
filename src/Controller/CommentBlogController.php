<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\CommentBlog;
use App\Entity\Blog;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CommentBlogRepository;
use App\Repository\BlogRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class CommentBlogController extends AbstractController
{
    #[Route('/addComment/{id}', name: 'Comment_add')]
    public function add(Blog $product,ManagerRegistry $doctrine,Request $request): Response
    {
        $comment = new CommentBlog();
        
            $comment->setUser($this->getUser());
            $comment->setBlog($product);
            $comment->setComment($request->get("comment"));
            $em= $doctrine->getManager();
            $em->persist($comment);
            $em->flush();

        return $this->redirectToRoute('afficheDetailsB', ['id' => $product->getId()]);
        
    }

    #[Route('/suppComment/{id}', name: 'Comment_remove')]
    public function remove(CommentBlog $comment,ManagerRegistry $doctrine): Response
    {
        $em= $doctrine->getManager();
        $em->remove($comment);
        $em->flush();

        return $this->redirectToRoute('afficheDetailsB', ['id' => $comment->getBlog()->getId()]);
    }

    #[Route('/afficheComment/{id}', name: 'Comment_affiche')]
    public function index(CommentBlogRepository $commentRepository,BlogRepository $blogRepository,$id): Response
    {
        $comments = $commentRepository->findBy(['blog' => $id]);
        //dd($comments);
        //$Product[] = new Product;
        
        foreach($comments as $comment)
        {
            
           // $prodid = $favoriteRepository->find($favorite->getProduct()->getId());
            $Comment[]=[
                'comment'=>$comment->getComment(),
                'userName'=>$comment->getUser()->getNom()
        ];
           // $Products[]=[$Product];
        }
        dd($Comment);

        return $this->render('blog/showDetalsBlog.html.twig', [
            'Comment' => $Comment,
        ]);
    }
    #[Route('/showCommentJSON/{id}', name: 'app_showCommentJSON')]
    public function showCommentJSON(CommentBlogRepository $repository,Request $request,NormalizerInterface $normalizer ,$id)
    {
        $cc= $repository->findBy(['blog' => $id]); 
        $data = [];

        foreach ($cc as $c) {
           
            $data[] = [
                'id' => $c->getId(),
                'comment' => $c->getComment(),
                'user' => $c->getUser()->getNom()
            ];
        }
        //dd($data);
        
            $normalized = $normalizer->normalize($data,'json',['groups'=>'CommentBlog_list']);
            //$jason = json_encode($normalized);
        
            
         $jason = json_encode($normalized);
        return new Response($jason);
     }
}
