<?php
namespace APP\controllers;
use APP\core\Mail;
use APP\models\User;
use APP\core\base\Model;
use APP\models\Panel;

class UserController extends AppController
{
	public $layaout = 'USER'; //Перераспределяем массив layaout
    public $BreadcrumbsControllerLabel = "CASHCALL.RU";
    public $BreadcrumbsControllerUrl = "/";

	public function registerAction()
	{

		if( isset($_SESSION['ulogin']['id']) ) redir('/panel/');

        $META = [
            'title' => 'Регистрация пользователя',
            'description' => 'Регистрация пользователя',
            'keywords' => 'Регистрация пользователя',
        ];

        $BREADCRUMBS['HOME'] = ['Label' => $this->BreadcrumbsControllerLabel, 'Url' => $this->BreadcrumbsControllerUrl];
        $BREADCRUMBS['DATA'][] = ['Label' => "Регистрация пользователя"];




       $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/styling/uniform.min.js"];

        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/styling/switchery.min.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/styling/switch.min.js"];

        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/validation/validate.min.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/styling/uniform.min.js"];
        $ASSETS[] = ["js" => "/assets/js/login_validation.js"];

        $ASSETS[] = ["js" => "/global_assets/js/demo_pages/form_checkboxes_radios.js"];



         \APP\core\base\View::setAssets($ASSETS);
        \APP\core\base\View::setMeta($META);
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);

        $user = new User; //Вызываем Моудль

        if ($_POST){

            $user->load($_POST); // Берем из POST только те параметры которые нам нужны

            if(!$user->validate($_POST) || !$user->checkUniq(CONFIG['USERTABLE']) )
            {
                $_SESSION['form_data'] = $user->ATR; //Сохраняем в сессию, чтобы у поьзователю было удобнее
                $user->getErrorsVali(); //Записываем ошибки в сессию
                redir("/user/");
            }


            $passorig = $user->ATR['password'];
            $user->ATR['password'] = password_hash($user->ATR['password'], PASSWORD_DEFAULT); // Хеш пароля

            $_SESSION['confirm'] = $user->ATR; //Базовые параметры
            //Доп. Параметры в сессию
            $_SESSION['confirm']['code'] = $code = random_str(5); //Код подтверждения

            if(isset($_COOKIE['ref'])) $_SESSION['confirm']['ref'] = $_COOKIE['ref']; //ID реферала
            //Доп. Параметры в сессию

            // Отправка на почту кода подтверждения
            Mail::sendMail("code",'Успешная регистрация '.CONFIG['NAME'],null,['to' => [['email' =>$user->ATR['email']]]]);

            //  mes ('ВНИМАНИЕ! Не закрывайте страницу браузера. Код подтверждения отправлен на почту. ');

            redir('/user/confirmRegister/');




        }





	}



	public function indexAction()
	{


	    //Если юзер залогинен, то редиректим его на панель
		if( isset($_SESSION['ulogin']['id']) ) redir('/panel/');

		if($_POST){

			$user = new User;

			if($user->login(CONFIG['USERTABLE'])){
				//АВТОРИЗАЦИЯ
				redir('/panel/');
				//АВТОРИЗАЦИЯ
			}
			else
			{
				$_SESSION['errors'] = "Логин/Пароль введены не верно";
                redir('/user/');

			}
		}


        $META = [
            'title' => 'Логин',
            'description' => 'Логин',
            'keywords' => 'Логин',
        ];
        \APP\core\base\View::setMeta($META);



        $BREADCRUMBS['HOME'] = ['Label' => $this->BreadcrumbsControllerLabel, 'Url' => $this->BreadcrumbsControllerUrl];
        $BREADCRUMBS['DATA'][] = ['Label' => "Логин"];
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);



        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/validation/validate.min.js"];
        $ASSETS[] = ["js" => "/global_assets/js/plugins/forms/styling/uniform.min.js"];
        $ASSETS[] = ["js" => "/assets/js/login_validation.js"];

        \APP\core\base\View::setAssets($ASSETS);






	}


	public function logoutAction()
	{
		if(isset($_SESSION['ulogin'])){
			$_SESSION['ulogin'] = array();
			redir('/user/login');
		}
	}




	public function confirmRegisterAction()
	{

		$user = new User;


        $META = [
            'title' => 'Регистрация пользователя',
            'description' => 'Регистрация пользователя',
            'keywords' => 'Регистрация пользователя',
        ];
        \APP\core\base\View::setMeta($META);




		if( !isset($_SESSION['confirm']['code']) )
		{

            $_SESSION['errors'] = "Код подтверждения устарел. Необходимо выполнить процедуру повторно.";
			redir('/user/register/');
		}

		//Проверка на сессию кода
		if(!empty($_POST['code']))
		{
			if($_POST['code'] == $_SESSION['confirm']['code'])
			{
				// ПИШЕМ В БАЗУ ДАННЫХ
				if($user->saveuser(CONFIG['USERTABLE']))
				{

                    Mail::sendMail("register",'Успешная регистрация '.CONFIG['NAME'],null,['to' => [['email' =>$_SESSION['confirm']['email']]]]);

//                    $_SESSION = array();

                    $_POST['email'] = $_SESSION['confirm']['email'];
                    $_POST['password'] = $_SESSION['confirm']['password2'];

                    $user->login(CONFIG['USERTABLE']);
					redir('/panel/');


				}
				else
				{
					$_SESSION['errors'] = "Ошибка базы данных. Попробуйте позже.";
                    redir('/user/confirmRegister/');
				}
				// ПИШЕМ В БАЗУ ДАННЫХ
			}
			else
			{
				$_SESSION['errors'] = "Код не совпдает с кодом в E-mail";
                redir('/user/confirmRegister/');

			}
		}
	}


	public function recoveryAction()
	{

        $META = [
            'title' => 'Восстановление пароля',
            'description' => 'Восстановление пароля',
            'keywords' => 'Восстановление пароля',
        ];

        $BREADCRUMBS['HOME'] = ['Label' => $this->BreadcrumbsControllerLabel, 'Url' => $this->BreadcrumbsControllerUrl];
        $BREADCRUMBS['DATA'][] = ['Label' => "Восстановление пароля"];

        \APP\core\base\View::setMeta($META);
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);

		if(!empty($_POST)){
			$user = new User;
			if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				if($user->checkemail(CONFIG['USERTABLE'], $_POST['email'])){
					$_SESSION['confirm']['recode'] = random_str(5);
					$_SESSION['confirm']['remail'] = $_POST['email'];
                    Mail::sendMail("resetpassword",' Сборс пароля в '.CONFIG['NAME'],null,['to' => [['email' =>$_POST['reminder-email']]]]);

                    $_SESSION['success'] = "Код для сброса пароля отправлен на почту. ";

					redir('/user/confirmRecovery/');
				}
				else
				{
					$_SESSION['errors'] = "Пользователь с таким E-mail не существует";
                    redir('/user/recovery/');
				}
			}
			else
			{
				$_SESSION['errors'] = "E-mail указан не корректно";
                redir('/user/recovery/');

			}
		}



	}
	// Страница ввода кода при сбросе пароля
	public function confirmRecoveryAction()
	{

        $META = [
            'title' => 'Восстановление пароля',
            'description' => 'Восстановление пароля',
            'keywords' => 'Восстановление пароля',
        ];

        $BREADCRUMBS['HOME'] = ['Label' => $this->BreadcrumbsControllerLabel, 'Url' => $this->BreadcrumbsControllerUrl];
        $BREADCRUMBS['DATA'][] = ['Label' => "Восстановление пароля"];

        \APP\core\base\View::setMeta($META);
        \APP\core\base\View::setBreadcrumbs($BREADCRUMBS);



		if( !isset($_SESSION['confirm']['recode']) )
		{
            $_SESSION['errors'] = "Код подтверждения устарел. Необходимо выполнить процедуру повторно.";
			redir('/user/recovery/');
		}


		if(!empty($_POST['code']))
		{
			if($_POST['code'] == $_SESSION['confirm']['recode'])
			{
				$user    = new User;
				$newpass = $user->newpass('user');
				if(!empty($newpass))
				{
					$_SESSION['confirm']['newpass'] = $newpass;
                    Mail::sendMail("newpass",  'Ваш новый пароль в '.CONFIG['NAME'],null,['to' => [['email' =>$_SESSION['confirm']['remail']]]]);
					$_SESSION = array();
					mes ('Новый пароль отправлен на почту!');
					redir('/user/');
				}
				else
				{
					$_SESSION['errors'] = "Ошибка базы данных. Попробуйте позже.";
                    redir('/user/confirmRecovery');
				}
			}
			else
			{
				$_SESSION['errors'] = "Код не совпдает с кодом в E-mail";
                redir('/user/confirmRecovery');

			}
		}
	}
	// Страница ввода кода при сбросе пароля
	public function refAction()
	{
		if(!empty($_GET['partner']))
		{
			if( !preg_match('/^[0-9]{1,5}$/', $_GET['partner']) )  exit('Неправильная реф.ссылка');
			setcookie('ref', $_GET['partner'], strtotime('+15 days'), '/');
			redir("/");
    //			header('Location: /');
		}
		else
		{
			exit ('Неправильная реф.ссылка');
		}
	}




	public function formAction()
	{
		if(!empty($_POST)){
			$_SESSION['form_data']['signup-email'] = $_POST['email'];
			$_SESSION['form_data']['signup-telephone'] = $_POST['telephone'];
			$_SESSION['form_data']['signup-username'] = $_POST['username'];
			redir('/user/register/');
		}
		exit();
	}
}
?>