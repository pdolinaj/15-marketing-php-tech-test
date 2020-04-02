<?php

class CodingFun
{
    public function getFibonacciSequence($resultArraySize)
    {
        if(!is_int($resultArraySize) || $resultArraySize < 1) {
            return [];
        }

        $result = [];

        for($count = 0; $count <= $resultArraySize - 1; $count++) {
            if($count < 2) {
                $result[] = $count;
            } else {
                $result[] = $result[$count-2] + $result[$count-1];
            }
        }
        return $result;
    }

    public function getCustomerBalances(array $customerTransactions)
    {
        //
        $output = [];
        foreach($customerTransactions as $transaction) {
            list($customerName, $balance) = explode('=', $transaction);

            if($customerName && is_numeric($balance)) {

                // trim + to lowercase
                $customerName = trim(strtolower($customerName));
                $balance = trim($balance);

                if(isset($output[$customerName])) {
                    $output[$customerName] += $balance;
                } else {
                    $output[$customerName] = $balance;
                }
            }
        }
        //order by key (customer name)
        ksort($output);

        return $output;
    }

    public function getLotteryWinnings($totalWinnings, $winningNumber, array $players)
    {
        $winnings = [];
        if(is_int($totalWinnings) && $totalWinnings >= 0 && is_int($winningNumber) && count($players) > 0) {

            $totalWinnersCount = 0;
            foreach($players as $name => $number) {

                // trim + to lowercase
                //do we care about upper/lower cases (peter VS Peter = same name?)
                $name = trim(strtolower($name));
                $number = trim($number);

                if($number == $winningNumber) {
                    //check if the same player won multiple times
                    if(isset($winnings[$name])) {
                        $winnings[$name] += 1;
                    } else {
                        $winnings[$name] = 1;
                    }
                    $totalWinnersCount++;
                }
            }

            if(count($winnings) > 0) {
                // calculate prize per winner round to 2 decimal places
                $prizePerWinner = round($totalWinnings / $totalWinnersCount, 2);
                //$prizePerWinner = $totalWinnings / $totalWinnersCount;
                // calculate final prizes per each winner
                foreach($winnings as $name => $numberOfTimesWon) {
                    $winnings[$name] = $numberOfTimesWon * $prizePerWinner;
                }
            }

            //sort by key (name)
            ksort($winnings);
        }

        return $winnings;
    }
}
