<?php

$configuration = setConfiguration();
$password = $configuration['password'];
$gift = $configuration['gift'];
$operations = $configuration['operations'];
play($password, $gift, $operations);

function setConfiguration()
{
    $gift = readline('Choisir la récompense. exemple : un bonbon puis appuyer sur entrée : ');
    $password = readline('Saisir le mot de passe (un caractère = une opération à réaliser) : ');
    $operations = addQuestions(strlen($password));
    return ['gift'=> $gift,'password'=>$password, 'operations'=> $operations];
}

function addQuestions($numberOfQuestions){
    $questions = [];
    $questions[0]['first number'] = readline('saisissez le nombre à additionner : ');
    $questions[0]['second number']= readline('saisissez le second nombre à additionner : ');
    for ($i =1 ; $i < $numberOfQuestions; $i++){
        $number = $i+1;
        echo "\n opération n° ". $number . " : \n";
        $questions[$i]['first number'] = readline('saisissez le nombre à additionner : ');
        $questions[$i]['second number']= readline('saisissez le second nombre à additionner : ');
    }
    return $questions;
}

function askQuestion ($number, $secondNumber, $letter, $word){
    $result = $number + $secondNumber;
    $resultProposed = readline("\n" . $number .' + ' . $secondNumber . ' = ');
    while ($resultProposed != $result){
        echo "Non ! Concentre toi ! \n";
        $resultProposed = readline($number .' + ' . $secondNumber . ' = ');
    }
    echo "\n Super ! voici une lettre du mot de passe : " . $letter." \n";
    $word .= $letter;
    
    return $word;
}

function cleanScreen()
{
    for ($i = 0 ; $i<100; $i++)
    {
        echo " \n";
    }
}

function win($word)
{
    echo "\n Bravo tu as gagné ! le mot de passe est : $word \n";
}

function startGame($gift)
{
    echo "Attention ! Le jeu va commencer ! \n Tu dois trouver un mot. \n 
    A chaque fois que tu réussis à trouver le bon résultat de l'addition, je te donne une lettre. \n
    Quand tu as le mot de passe, viens me le dire, et tu gagne " .$gift . " ! \n C'est parti ! \n";
}

function putPasswordInOperationsArray($password, $operations)
{
    $passwordArray = str_split($password);
    foreach ($operations as $key => $operation)
    {
        $operations[$key]['letter'] = $passwordArray[$key];
    }
    return $operations;
}

function launchOperations($operations)
{
    $word = '';
    foreach ($operations as $key => $operation){
        if ($key > 1)
        { echo " pour l'instant, le mot de passe est : ". $word ."\n" ;
        }
        $word = askQuestion($operation['first number'], $operation['second number'], $operation['letter'], $word);
    }
    return $word;
}

function play($password, $gift, $operations)
{
    cleanScreen();
    startGame($gift);
    
    $operations = putPasswordInOperationsArray($password, $operations);
    
    $word = launchOperations($operations);
    
    win($word);
}
