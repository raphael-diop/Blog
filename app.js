//on met dans un tableau ttes les images
const items = document.querySelectorAll('img');
//longueur slide = nbr de slides
const nbSlide = items.length;
//selction bouton suivant et bouton précedent
const suivant = document.querySelector('.right');
const precedent = document.querySelector('.left');
//conteur de slides
let count = 0;

function slideSuivante(){
    //on enleve la classe actib=ve a la page précédente
    items[count].classList.remove('active');

    //on avance tant que le nombre de slide est positif
    if(count < nbSlide - 1){
        count++;
    } else {
        count = 0;
    }

    //on ajoute la classe a la slide suivante
    items[count].classList.add('active')
    
    
}
suivant.addEventListener('click', slideSuivante)

//meme principe mais dans le sens inverse
function slidePrecedente(){
    items[count].classList.remove('active');

    if(count > 0){
        count--;
    } else {
        count = nbSlide - 1;
    }

    items[count].classList.add('active')
    // console.log(count);
    
}
precedent.addEventListener('click', slidePrecedente)