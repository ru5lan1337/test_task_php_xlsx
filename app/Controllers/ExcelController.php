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
            $dataUsers = $excelReader->reader(User::getExcelNaming(), User::getExcelNumSheet()) as $dataUser;
            foreach ($dataUsers as $dataUser) {
                $users[$dataUser['id']] = new User($dataUser['id'], $dataUser['fullName'], $dataUser['startBalance']);
            }

            //get transaction
            $dataTransactions = $excelReader->reader(Transaction::getExcelNaming(), Transaction::getExcelNumSheet());
            foreach ($dataTransactions as $dataTransactionFromExcel) {
                $transaction = new Transaction($dataTransactionFromExcel['id'], $dataTransactionFromExcel['sum']);
                if(isset($users[$transaction->getId()])){
                    $users[$transaction->getId()]->addTransaction($transaction);
                } else{
                    $transactionIdsNotFound[] = $transaction->getId();
                }
            }
            if (isset($transactionIdsNotFound)) {
                return $this->excelError('id - ' . Helper::getStrArray($transactionIdsNotFound) . 'transaction not found user');
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