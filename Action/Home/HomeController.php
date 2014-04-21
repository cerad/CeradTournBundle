<?php

namespace Cerad\Bundle\TournBundle\Action\Home;

use Symfony\Component\HttpFoundation\Request;

use Cerad\Bundle\CoreBundle\Action\ActionController;

class HomeController extends ActionController
{
    public function action(Request $request, $model, $userPerson = null)
    {   
        // Special case for session timeouts
        if (!$this->isGranted('ROLE_USER'))
        {
            return $this->redirectResponse('cerad_tourn__welcome');
        }
        // Make sure have a project person
        $model->process();
        
        // The template
        $tplData = array();
        $tplName = $request->attributes->get('_template');
        
        return $this->regularResponse($tplName,$tplData);
    }    
}
