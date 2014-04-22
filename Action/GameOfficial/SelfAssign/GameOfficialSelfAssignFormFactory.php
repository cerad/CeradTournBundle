<?php

namespace Cerad\Bundle\TournBundle\Action\GameOfficial\SelfAssign;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Validator\Constraints\NotBlank  as NotBlankConstraint;

use Cerad\Bundle\UserBundle\ValidatorConstraint\UsernameOrEmailExistsConstraint;

use Cerad\Bundle\CoreBundle\Action\ActionFormFactory;

class GameOfficialSelfAssignFormFactory extends ActionFormFactory
{
    protected function getChoices($gameOfficial,$person)
    {
        $personName = $person->getName();
        $personNameFull = $personName->full;
        
        $assignState = $gameOfficial->getAssignState();
        
        if ($assignState == 'Open' || $assignState == '')
        {
            $choices = array($person->getGuid() => $personNameFull);
            return $choices;
        }
        return array();
    }
    public function create(Request $request, $model)
    {   
        $actionUrlParams = array(
            'game' => $model->game->getNum(),
            'slot' => $model->gameOfficial->getSlot(),
        );
        $formOptions = array(
            'method' => 'POST',
            'action' => $this->generateUrl('cerad_tourn__game_official__self_assign',$actionUrlParams),
            'attr'   => array(
                'class' => 'cerad_common_form1',
            ),
            'required' => false,
        );
        $constraintOptions = array();
        
        $choices = $this->getChoices($model->gameOfficial,$model->userPerson);
        $formData = array('choices' => $choices);
        
        $builder = $this->formFactory->create('form',$formData,$formOptions);

        $builder->add('choices');
        
        $builder->add('signup', 'submit', array(
            'label' => 'Signup',
            'attr' => array('class' => 'submit'),
        ));        
       
        return $builder;
        
        $builder->add('username','text', array(
            'required' => true,
            'label'    => 'Email',
            'trim'     => true,
            'constraints' => array(
                new UsernameOrEmailExistsConstraint($constraintOptions),
            ),
            'attr' => array('size' => 30),
         ));
         $builder->add('password','password', array(
            'required' => true,
            'label'    => 'Password',
            'trim'     => true,
            'constraints' => array(
                new NotBlankConstraint($constraintOptions),
            ),
            'attr' => array('size' => 30),
        ));
        $builder->add('rememberMe','checkbox',array(
            'required' => false,
            'label'    => 'Remember Me',
        ));
        
        $builder->add('login', 'submit', array(
            'label' => 'Log In',
            'attr'  => array('class' => 'submit'),
        ));
        
        // Actually a form
        return $builder;
    }
}