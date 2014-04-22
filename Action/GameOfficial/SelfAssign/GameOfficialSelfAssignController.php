<?php
namespace Cerad\Bundle\TournBundle\Action\GameOfficial\SelfAssign;

use Symfony\Component\HttpFoundation\Request;

use Cerad\Bundle\GameBundle\FormType\GameOfficial\SelfAssignSlotFormType;

use Cerad\Bundle\CoreBundle\Action\ActionController;

class GameOfficialSelfAssignController extends ActionController
{
    /* =====================================================
     * Either assign or self assign
     * Model is injected, some checks have been made
     */
    public function action(Request $request, $model, $form)
    {   
        // Special case for session timeouts
        if (!$this->isGranted('ROLE_USER'))
        {
            return $this->redirectResponse('cerad_tourn__welcome');
        }
        $form->handleRequest($request);

        if ($form->isValid())
        {   
            $response = $model->process();
            
            if ($response) return $response;
            
            return $this->redirect($model['_route'],array('game' => $model['game']->getNum()));
        }

        // And render, pass the model directly to the view?
        $tplData = array();
        $tplData['form'] = $form->createView();
        $tplData['game'] = $model->game;
        $tplData['gameOfficial'] = $model->gameOfficial;

        return $this->regularResponse($request->get('_template'),$tplData);
    }
    public function createForm($request,$model)
    {
        $game = $model->game;
        $slot = $model->slot;
        
        $builder = $this->actonHelper->createFormBuilder($model);
        
        $builder->setAction($this->actionHelper->generateUrl($request->get('_route'),
            array('game' => $game->getNum(),'slot' => $slot)
        ));
      //$builder->setMethod('POST'); // default
        
      //$builder->add('slots','collection',array('type' => new SelfAssignSlotFormType($model['officials'])));
        
        $builder->add('gameOfficial',new SelfAssignSlotFormType());
        
        $builder->add('assign', 'submit', array(
            'label' => 'Request Assignment',
            'attr' => array('class' => 'submit'),
        ));        
         
        return $builder->getForm();
    }
}
