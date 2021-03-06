<?php

namespace Cerad\Bundle\TournBundle\Action\Welcome;

use Symfony\Component\HttpFoundation\Request;

//  Symfony\Component\Form\FormInterface;

use Cerad\Bundle\CoreBundle\Action\ActionController;

class WelcomeController extends ActionController
{
    public function action(Request $request, $model)
    {   
        // Special case for session timeouts
        if ($this->isGranted('ROLE_USER'))
        {
            return $this->redirectResponse('cerad_tourn__home');
        }
        $tplData = array();
      //$tplData['project'] = $model->getProject();
        
        $tplName = $request->attributes->get('_template');
        
        return $this->regularResponse($tplName,$tplData);
    }    
}
