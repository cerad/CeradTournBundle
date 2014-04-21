<?php

namespace Cerad\Bundle\TournBundle\Action\UserPerson\Create;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\FormInterface;

use Cerad\Bundle\CoreBundle\Action\ActionController;

class UserPersonCreateController extends ActionController
{   
    public function action(Request $request, UserPersonCreateModel $model, FormInterface $form)
    {   
        $form->handleRequest($request);

        if ($form->isValid()) 
        {   
            $model->process();
            
          //$formAction = $form->getConfig()->getAction();
          //return new RedirectResponse($formAction);  // To form
            $personId = $model->person->getId();
            return $this->redirectResponse('cerad_user__user__login');
        }
        
        $tplData = array();
        $tplData['form'] = $form->createView();
        
        $tplName = $request->attributes->get('_template');
        return $this->regularResponse($tplName, $tplData);

    }    
}
