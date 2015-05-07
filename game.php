<?php

/*
 * The MIT License
 *
 * Copyright 2015 Ahmad Waskita.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Description of game
 *
 * @author Ahmad Waskita
 * 
 */
require 'Player.class.php';

$control;
$counter = 0;
$players = [];
$show = false;
$info = false;

function startScreen() {
    echo "\n====================================\n";
    echo "Welcome to the Battle Arena\n";
    echo "--------------------------------------\n";
    echo "Description: \n";
    echo "1. type \"new\" to create a character\n";
    echo "2. type \"start\" to begin the fight\n";
    echo "3. type \"exit\" to exit program\n";
    echo "--------------------------------------\n";
}

startScreen();
echo "Current Player: ";
echo $counter;
echo "\n";
echo "MaxPlayer 2\n";
$control = fgets(STDIN);
$control = trim(strtolower($control));


while (1) {
    if ($show == true) {
        startScreen();
        echo "Current Player: ";
        echo $counter;
        echo "\n";
        foreach ($players as $player) {
            echo $player->getName();
        }
        echo "MaxPlayer 2\n";
        $control = fgets(STDIN);
        $control = trim(strtolower($control));
        $show = false;
    }
    if ($control == "new") {
        startScreen();
        if ($counter > 1) {
            echo "====================================";
            echo "\nMax Player Reached, battle will start!";
            $control = "start";
        } else {
            echo "Put Player Name: ";
            $playersName = fgets(STDIN);
            //array_push($players, new Player($playersName));
            //array_push($valid, $playersName);
            while (array_key_exists($playersName, $players)) {
                echo "\nName already exist. Please enter again:\n";
                echo "Put Player Name: ";
                $playersName = fgets(STDIN);
            }
            $players[$playersName] = new Player($playersName);
            ++$counter;
            echo $counter;
            echo "\nMax Player 2\n";
            $show = true;
        }
    }
    if ($control == "start") {
        if ($counter < 2) {
            echo "\n###################################\n";
            echo "Min Player is 2 to start the game!";
            $show = true;
        } else {
            while (1) {
                echo "\n====================================\n";
                echo "Welcome to the Battle Arena\n";
                echo "--------------------------------------\n";
                echo "Battle Start: \n";
                echo "who will attack: ";
                $player1 = fgets(STDIN);
                while (!array_key_exists($player1, $players)) {
                    echo "player not found. enter again: \n";
                    $player1 = fgets(STDIN);
                }
                echo "who attacked: ";
                $player2 = fgets(STDIN);
                while (($player2 == $player1) or ( !array_key_exists($player2, $players))) {
                    echo "cannot use this player. enter again: \n";
                    $player2 = fgets(STDIN);
                }
                //each attack will reduce attacker mana by 8 and reduce target blood by 20
                $players[$player2]->blood = $players[$player2]->blood - 20;
                $players[$player1]->mana = $players[$player1]->mana - 8;

                echo "\nBattle Start: \n";
                echo "who will attack: $player1\n";
                echo "who attacked: $player2\n";
                echo "Description:\n";
                echo $players[$player1]->getName() . " : manna = " . $players[$player1]->mana . ", blood = " . $players[$player1]->blood . "\n";
                echo $players[$player2]->getName() . " : manna = " . $players[$player2]->mana . ", blood = " . $players[$player2]->blood . "\n";
                if (($players[$player1]->blood == 0) or ( $players[$player2]->blood == 0)) {
                    if ($players[$player1]->blood > 0) {
                        echo "\nThe winner is: $player1";
                    }
                    if ($players[$player2]->blood > 0) {
                        echo "\nThe winner is: $player2";
                    }
                    echo "\n########  GAME OVER  #########\n\n";
                    break;
                }
            }
            break;
        }
    }

    if ($control == "exit") {
        echo "\n####################################";
        echo "\n*********    GOOD BYE   *********";
        echo "\n####################################\n";
        break;
    } else {
        echo "\n####################################";
        echo "\n*********    TRY AGAIN   *********";
        $show = true;
    }
}