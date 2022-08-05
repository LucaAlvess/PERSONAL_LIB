<?php

namespace App\Controllers;

use App\Controllers\Template\TemplateController;
use App\Lib\Controllers\Page;
use App\Models\Entity\User;
use App\Lib\Utils\Error;
use App\Lib\Connection\Transaction;
use App\Lib\Utils\LOG\LoggerTXT;
use App\Lib\Views\Render\View;
use Exception;

class UserController extends Page
{
    public function register(array $data)
    {
        unset($data[0]);

        try {
            Transaction::open('db_config');
            Transaction::setLogger(new LoggerTXT('tmp/log_update.txt'));
            $user = new User();
            $user->storeDataFromArray($data);
            $user->saveData();

            Transaction::close();
        } catch (Exception $e) {
            Transaction::rollback();
            $error = new Error($e);
            $error->render();
        }
    }

    public function edit()
    {
        try {
            Transaction::open('db_config');
            $id = $this->getUrlParam();
            $user = new User($id);
            $data = $user->getDataToArray();

            $content = View::render('user/update', [
                'NAME' => $data['name'] ?? '',
                'PASSWORD' => $data['password'] ?? '',
                'ID' => $id
            ]);
            Transaction::close();
            echo TemplateController::getTemplate('Atualizar', $content);
        } catch (Exception $e) {
            Transaction::rollback();
        }
    }

    public function update($data)
    {
        unset($data['url']);
        $data['id'] = $this->getUrlParam();


        try {
            Transaction::open('db_config');

            $user = new User();
            $user->storeDataFromArray($data);
            $user->updateData();

            Transaction::close();
        } catch (Exception $e) {
            Transaction::rollback();
        }
    }
}