<?php
/*
 * This file is part of the WSUserBundle package.
 *
 * (c) Benjamin Georgeault <https://github.com/WedgeSama/> 
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WS\UserBundle\Tools;

use Symfony\Component\DependencyInjection\ContainerInterface;
use WS\UserBundle\Model\UserInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Http\Session\SessionAuthenticationStrategyInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormError;

class UserTools {

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var EncoderFactory
     */
    private $enc;

    /**
     * User class
     * 
     * @var string
     */
    private $userClass;

    /**
     * @var \WS\UserBundle\Model\UserRepository
     */
    private $repo;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var SessionAuthenticationStrategyInterface
     */
    private $sessionStrategy;

    /**
     * @var UserCheckerInterface
     */
    private $userChecker;

    /**
     * @var SecurityContextInterface
     */
    private $context;

    /**
     * @var string
     */
    private $firewall;

    public function __construct(ContainerInterface $container, 
        EncoderFactory $enc, EntityManager $em, 
        SecurityContextInterface $context, UserCheckerInterface $userChecker, 
        SessionAuthenticationStrategyInterface $sessionStrategy, $firewall) {
        $this->container = $container;
        $this->enc = $enc;
        $this->em = $em;
        $this->sessionStrategy = $sessionStrategy;
        $this->userChecker = $userChecker;
        $this->context = $context;
        $this->firewall = $firewall;
    }

    /**
     * Init the service
     */
    public function initConfig() {
        $this->userClass = $this->container->getParameter('ws_user.user_class');
        $this->repo = $this->em->getRepository($this->userClass);
    }

    /**
     * Create a new user. Enable it if check_email is false.
     * 
     * @return UserInterface
     */
    public function createNewUser() {
        return $this->repo->createUser();
    }

    /**
     * Create the register form
     * 
     * @param UserInterface $user
     * @param array $options
     * @return \WS\UserBundle\Form\RegisterType
     */
    public function createRegisterForm(UserInterface $user, $options = array()) {
        $formClass = $this->container->getParameter(
                'ws_user.register.form_class');
        
        return $this->container->get('form.factory')
            ->create(new $formClass(), $user, $options);
    }

    /**
     * Create the password ask form
     *
     * @param array $options
     * @return \WS\UserBundle\Form\PasswordAskType
     */
    public function createPasswordAskForm($options = array()) {
        $formClass = $this->container->getParameter(
                'ws_user.password_reset.form_class_ask');
        
        return $this->container->get('form.factory')
            ->create(new $formClass(), null, $options);
    }

    /**
     * Create the password reset form
     *
     * @param UserInterface $user
     * @param array $options
     * @return \WS\UserBundle\Form\PasswordResetType
     */
    public function createPasswordResetForm(UserInterface $user, $options = array()) {
        $formClass = $this->container->getParameter(
                'ws_user.password_reset.form_class_reset');
        
        return $this->container->get('form.factory')
            ->create(new $formClass(), $user, $options);
    }

    /**
     * Save the user in the database. Update password if exist pass.
     * 
     * @param UserInterface $user
     */
    public function saveUser(UserInterface $user) {
        if ($user->getPass()) {
            $encoder = $this->enc->getEncoder($user);
            $password = $encoder->encodePassword($user->getPass(), 
                    $user->getSalt());
            $user->setPassword($password);
        }
        
        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * Generate a unique token for a user.
     * 
     * @param UserInterface $user
     */
    public function initUserToken(UserInterface $user, $expire = true) {
        $user->setToken(str_replace(".", "", uniqid("", true)));
        
        if ($expire) {
            $interval = $this->container->getParameter('ws_user.token_expire');
            $date = new \DateTime();
            $date->add(new \DateInterval($interval));
            $user->setTokenExpireAt($date);
        }
    }

    /**
     * Delete the token for a user
     * 
     * @param UserInterface $user
     */
    public function deleteToken(UserInterface $user) {
        $user->setToken();
        $user->setTokenExpireAt();
    }

    /**
     * Login a user
     * 
     * @param UserInterface $user
     */
    public function loginUser(UserInterface $user) {
        $this->userChecker->checkPostAuth($user);
        
        $token = new UsernamePasswordToken($user, null, $this->firewall, 
                $user->getRoles());
        
        $this->context->setToken($token);
    }

    /**
     * Get the user by token
     * 
     * @return UserInterface
     */
    public function findByToken($token, $active = false) {
        return $this->repo->findOneBy(
                array(
                        'token' => $token, 
                        'enable' => $active 
                ));
    }

    /**
     * Get the user by username or email
     *
     * @return UserInterface
     */
    public function findByUsernameOrEmail($username) {
        return filter_var($username, FILTER_VALIDATE_EMAIL) ? $this->repo->findOneByEmail(
                $username) : $this->repo->findOneByUsername($username);
    }

    /**
     * Validate the password ask form
     * 
     * @param FormInterface $form
     * @return null|UserInterface
     */
    public function validPasswordAskForm(FormInterface $form) {
        if (! $form->isValid())
            return null;
        
        $data = $form->getData();
        $user = $this->findByUsernameOrEmail($data['username']);
        
        if ($user)
            return $user;
        
        $form->get('username')
            ->addError(
                new FormError(
                        $this->container->get('translator')
                            ->trans('ws_user_bundle.user_password.ask', array(), 
                                'validators')));
        
        return null;
    }

    /**
     * Check if token is expire
     * 
     * @param UserInterface $user
     * @return boolean
     */
    public function tokenIsExpire(UserInterface $user) {
        if ($user->getTokenExpireAt() != null && $user->getTokenExpireAt()
            ->getTimestamp() > time())
            return false;
        else if ($user->getToken() != null)
            return false;
        
        return true;
    }

}