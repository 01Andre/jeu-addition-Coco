<?php
welcome();
$configuration = setConfiguration();
$password = $configuration['password'];
$gift = $configuration['gift'];
$operations = $configuration['operations'];
$operations = putPasswordInOperationsArray($password, $operations);
cleanScreen();
startGame($gift);
play($operations);

function welcome()
{
    echo "Jeu sur terminal. Pas de distraction, pas de superflu.\n
    Le principe est simple: \n
    -L'enfant doit trouver un mot de passe en résolvant des additions. Il vous communiquera le mot de passe, et gagnera une récompense (bisou, bonbon...)\n
    -rentrez une récompense, choisissez un mot de passe (1 caractère par opération), et les nombres à additionner.\n
    -Personnellement, je fais du no limit avec ma fille: les doigts, la tête, l'ardoise, ce qu'elle veut, sauf papa.\n\n\n\n";
}

function setConfiguration()
{
    $gift = readline('Choisir la récompense. exemple : "un bonbon" ; puis appuyer sur entrée : ');
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
    $resultProposed = displayAddition($number, $secondNumber);
    while ($resultProposed != $result){
        echo "Non ! Concentre toi ! \n";
        $resultProposed = displayAddition($number, $secondNumber);
    }
    echo "\n Super ! voici une lettre du mot de passe : " . $letter." \n";
    $word .= $letter;
    
    return $word;
}

function displayAddition($number, $secondNumber)
{
    return readline("\n" . $number .' + ' . $secondNumber . ' = ');
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
    Ecris la solution de chaque addition, et appuie sur la touche Entrée.\n 
    A chaque fois que tu réussis à trouver le bon résultat de l'addition, je te donne une lettre. \n
    Quand tu as le mot de passe, viens me le dire, et tu gagne $gift ! \n C'est parti ! \n";
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

function play($operations)
{
    $word = launchOperations($operations);
    win($word);
}
