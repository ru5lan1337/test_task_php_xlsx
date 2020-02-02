<?php

namespace App\Controllers;

use App\Service\ExcelReader;
use App\Service\Helper;
use App\Model\User;
use App\Model\Transaction;

class ExcelController extends Controller
{
    public function index()
    {

        return $this->response->render('excel.index', []);
    }

    public function upload()
    {
        //load
        try {
            $excelReader = new ExcelReader($this->request->files['excel']['tmp_name'], [
                0 => 'first',
                1 => 'second'
            ]);

            //get users
            foreach ($excelReader->reader(User::getExcelNaming(), User::getExcelNumSheet()) as $dataUser) {
                $users[] = new User($dataUser['id'], $dataUser['fullName'], $dataUser['startBalance']);
            }

            //get transaction
            foreach ($excelReader->reader(Transaction::getExcelNaming(), Transaction::getExcelNumSheet()) as $dataTransactionFromExcel) {
                $transaction = new Transaction($dataTransactionFromExcel['id'], $dataTransactionFromExcel['sum']);
                foreach ($users as $user) {
                    if ($user->getId() == $transaction->getId()) {
                        $user->addTransaction($transaction);
                        $transaction = false;
                        break;
                    }
                }
                if ($transaction) {
                    $transactionIdsNotFound[$transaction->getId()] = true;
                }
            }
            if (isset($transactionIdsNotFound)) {
                return $this->excelError('id - ' . Helper::getStrByKeyArray($transactionIdsNotFound) . 'transaction not found user');
            }


            //calculate
            foreach ($users as $user) {
                $user->calculateBalance();
                $userResult['fullName'] = $user->getFullName();
                $userResult['balance'] = $user->getBalance();
                $usersResult[] = $userResult;
            }

        } catch (\Exception $e) {
            return $this->response->render('excel.error', $e->getMessage());
        }
        return $this->response->render('excel.result', $usersResult);
    }

}