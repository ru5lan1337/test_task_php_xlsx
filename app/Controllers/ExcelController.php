<?php

namespace App\Controllers;

use App\Service\ExcelReader;
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
            $dataUsers = $excelReader->reader(User::getExcelNaming(), User::getExcelNumSheet());
            foreach ($dataUsers as $dataUser) {
                $users[$dataUser['id']] = new User($dataUser['id'], $dataUser['fullName'], $dataUser['startBalance']);
            }

            //get transaction
            $dataTransactions = $excelReader->reader(Transaction::getExcelNaming(), Transaction::getExcelNumSheet());
            foreach ($dataTransactions as $dataTransactionFromExcel) {
                $transaction = new Transaction($dataTransactionFromExcel['id'], $dataTransactionFromExcel['sum']);
                if(isset($users[$transaction->getUserId()])){
                    $users[$transaction->getUserId()]->addTransaction($transaction);
                } else{
                    $transactionIdsNotFound[] = $transaction->getUserId();
                }
            }
            if (isset($transactionIdsNotFound)) {
                return $this->excelError('id - ' . implode($transactionIdsNotFound) . 'transaction not found user');
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