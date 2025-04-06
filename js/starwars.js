document.addEventListener('DOMContentLoaded', () => {
    createStars();
    createPlanets();
});

function createStars() {
    const starsContainer = document.querySelector('.stars');
    for (let i = 0; i < 300; i++) { 
        const star = document.createElement('div');
        star.classList.add('star');
        star.style.top = `${Math.random() * 100}vh`;
        star.style.left = `${Math.random() * 100}vw`;
        star.style.animationDelay = `${Math.random() * 5}s`; 
        starsContainer.appendChild(star);
    }
}

function createPlanets() {
    console.log('Creating planets'); 

    const planetsContainer = document.querySelector('.planets');
    const planetClasses = ['planet-small', 'planet-medium', 'planet-large', 'planet-extra-large', 'planet-giant'];
    
    planetClasses.forEach((planetClass) => {
        const planet = document.createElement('div');

        planet.classList.add('planet', planetClass); 
        planet.style.top = `${Math.random() * 100}vh`;
        planet.style.left = `${Math.random() * 100}vw`;
        planet.style.animationDuration = `${15 + Math.random() * 10}s`;
        
        planetsContainer.appendChild(planet);
    });
}