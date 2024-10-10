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
    const planetsContainer = document.querySelector('.planets');
    const planetSizes = ['planet-small', 'planet-medium', 'planet-large'];
    
    for (let i = 0; i < 5; i++) {
        const planet = document.createElement('div');
        const randomSize = planetSizes[Math.floor(Math.random() * planetSizes.length)];
        planet.classList.add('planet', randomSize);
        planet.style.top = `${Math.random() * 100}vh`;
        planet.style.left = `${Math.random() * 100}vw`;
        planet.style.animationDuration = `${15 + Math.random() * 10}s`; 
        planetsContainer.appendChild(planet);
    }
}

function toggleForms() {
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const showRegister = document.getElementById('show-register');
    const showLogin = document.getElementById('show-login');

    showRegister.addEventListener('click', (e) => {
        e.preventDefault();
        loginForm.classList.add('fade-out');
        registerForm.classList.remove('fade-out');
        registerForm.classList.add('fade-in');

        setTimeout(() => {
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
        }, 500);
    });

    showLogin.addEventListener('click', (e) => {
        e.preventDefault();
        registerForm.classList.add('fade-out');
        loginForm.classList.remove('fade-out');
        loginForm.classList.add('fade-in');

        setTimeout(() => {
            registerForm.style.display = 'none';
            loginForm.style.display = 'block';
        }, 500); 
    });
}

createStars();
createPlanets();
toggleForms();

