<?php
namespace App\Controller;

use App\Document\URL;
use Doctrine\ODM\MongoDB\DocumentManager;
use MongoDB\BSON\Regex;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class URLController extends AbstractController
{
    private DocumentManager $dm;
    public function __construct(DocumentManager $dm)    { $this->dm = $dm; }	

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(Request $request): Response
    {   
        return $this->render('index.html');
    }

    #[Route('/{shortKey}', name: 'get', methods: ['GET'])]
    public function get(string $shortKey): RedirectResponse
    {
        $site = $this->dm->getRepository(URL::class)->createQueryBuilder()->distinct('site')->field('shortKey')->equals(new Regex($shortKey, 'xi'))->getQuery()->execute();
		return $this->redirect($site[0]);
    }
	
	#[Route('/', name: 'post', methods: ['POST'])]
	public function post(Request $request, SerializerInterface $serializer): Response
	{
		$this->dm->persist($serializer->deserialize($request->getContent(), URL::class, 'json'));
		$this->dm->flush();		
		return new Response ('201: URL was added');
	}
}
