<?php
namespace UserBundle\Controller;

use AppBundle\Entity\Year;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends Controller
{
    /**
     * @Route("/google/check", name="google_check")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function checkAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $um = $this->get('user.manager');

        /*** @var \Google_Service_Oauth2_Userinfoplus $response */
        $response = $this->get('google.oauth')->getResponse();
        if ($response) {
            $user = $em->getRepository('UserBundle:User')->loadUserByUsername($response->getId());

            if (!$user) {
                /** @var Year $year */
                $year = $this->get('year.manager')->getCurrentYear();

                if ($response->getHd() == 'npu.edu.ua') {
                    $user = $um->createTeacher($response, $year);
                } elseif ($response->getHd() == 'std.npu.edu.ua') {
                    $user = $um->createStudent($response, $year);
                }

                $em->persist($user);
            }

            $um->update($user, $response);
            $em->flush();
            $um->authorize($user, $request);

            return $this->redirectToRoute('my_profile');
        }
        $this->addFlash('invalid_domains', 'invalid_domains');
        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/logout", name="logout")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @internal param Request $request
     */
    public function logoutAction()
    {
        $this->get('security.token_storage')->setToken(null);
        return $this->redirectToRoute('homepage');
    }

}