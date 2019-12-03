<?php
$sentences = ["Le chat ... fatigué",
"Le chien ... le chat sont fatigués",
"Constance ... belle",
"J'aime les glaces ... les gâteaux", 
"Tortor ... Constance font du bruit",
"Papa ... en colère",
"Le bateau ... arrivé",
"Le gâteau ... délicieux", 
"Constance ... sa copine Margaux vont à la plage",
"Le roi, la reine ... le petit prince sont venus chez moi"];
$answer = ["est","et","est","et", "et","est", "est","est","et", "et"];

initializeGame();
echo "\n bravo  tu as gagné !!!! \n";


function initializeGame()
{
    $sentencesAndAnswers = writeSentences();
    skipLines();
    showRule();
    playGame($sentencesAndAnswers);
}

function playGame($sentences)
{
    foreach ($sentences as $key => $sentence)
    { if ($key>0){
        echo "\n bravo !\n";
    }
    echo $sentence['sentence'] . "\n" ;
    $cocosAnswer = readline("\n on écrit et ou est ? \n ");
    
    askQuestion ($cocosAnswer, $sentence); 
    
} 
}

function writeSentences()
{
    $answer ="";
    while ($answer == "")
    {
        $sentences[] = addSentence();
        echo "\n";
        $answer = readline("Si vous voulez ajouter une phrase, validez. Sinon, appuyez sur 'n' et validez.");
    }
    
    return prepareArrayOfSentencesAndAnswers($sentences);
}
function addSentence($wrong = "")
{
    echo $wrong . "ajoutez une phrase contenant 'et' ou 'est' . ATTENTION, UN SEUL 'ET' OU 'EST' PAR PHRASE ! \n";
    $sentence = readline();
    if (strpos(strtolower($sentence),"est") == false && strpos(strtolower($sentence),"et") == false){
        $sentence = addSentence("\nLa phrase ne contient pas 'et ou 'est'. \n");
    }
    return $sentence;
}

function prepareArrayOfSentencesAndAnswers($sentences)
{
    foreach ($sentences as $key=>$sentence) {
       $sentenceInArray = preg_split("/\s|'/", $sentence);
        foreach ($sentenceInArray as $keyword =>$word) {
            if ($word == "et" || $word == "est"){
                $sentenceInArray[$keyword] = "...";
                $answer = $word;
            }
        }
        $sentencesAndAnswers[$key]['sentence'] = implode(" ", $sentenceInArray);
        $sentencesAndAnswers[$key]['answer'] = $answer;
    }
    return $sentencesAndAnswers;
}

function askQuestion($cocosAnswer ,$sentence)
{
    while (strtolower($cocosAnswer) != strtolower($sentence['answer'])){
        skipLines();
        $showRule = readline("FAUX ! si tu veux relire la règle, écris 'oui' , sinon, appuie sur entrée ");
        if($showRule == "oui")
        {
            showRule();
        }
        echo $sentence['sentence'] . "\n" ;
        $cocosAnswer = readline("\n on écrit 'et' ou 'est' ? \n ");
        
    }
}

function showRule()
{
    $answer ="";
    while ($answer !="ok"){
        echo "\n\nQuand on peut dire 'sera' , on écrit 'EST'. \nQuand on peut dire 'et puis' , on écrit 'ET' \n *attention, s'il y a plusieurs ... dans la phrase, ne t'occupe que des derniers\n\n";
        $answer = readline("écris OK si tu as compris \n");
    }
    skipLines();
}

function skipLines()
{
    for($i= 0 ; $i<50;$i++){
        echo "\n"; 
    }
}
