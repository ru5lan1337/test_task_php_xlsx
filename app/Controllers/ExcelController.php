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
            $excelReader = new ExcelReader($this->request->files['excel']['tmp_name'], 2);
        } catch (\Exception $e) {
            return $this->excelError($e->getMessage());
        }

        //get users
        try {
            $dataUsersFromExcel = $excelReader->reader(User::getExcelNaming(), User::getExcelNumSheet());
            foreach ($dataUsersFromExcel as $dataUser) {
                $users[] = new User($dataUser['id'], $dataUser['fullName'], $dataUser['startBalance']);
            }
        } catch (\Exception $e) {
            return $this->excelError($e->getMessage());
        }


        //get transaction
        try {
            $dataTransactionsFromExcel = $excelReader->reader(Transaction::getExcelNaming(), Transaction::getExcelNumSheet());
            foreach ($dataTransactionsFromExcel as $key => $dataTransactionFromExcel) {
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
        } catch (\Exception $e) {
            return $this->excelError($e->getMessage());
        }

        //calculate
        foreach ($users as $user) {
            $user->calculateBalance();
            $userResult['fullName'] = $user->getFullName();
            $userResult['balance'] = $user->getBalance();
            $usersResult[] = $userResult;
        }

        return $this->response->render('excel.result', $usersResult);
    }

    private function excelError($error)
    {
        return $this->response->render('excel.error', $error);
    }

}