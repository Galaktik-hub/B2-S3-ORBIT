const light = document.getElementById('light');
const dark = document.getElementById('dark');
const container = document.querySelector('.container');
const statu = document.querySelector('.status');
const TitleBot = document.querySelector('.TitleBot');

light.addEventListener('click', () => {
    light.classList.add('none');
    light.classList.remove('visible');
    dark.classList.add('visible');
    dark.classList.remove('none');
    container.classList.remove('darkmode');
    statu.classList.remove('color-white');
    TitleBot.classList.remove('color-white');
});

dark.addEventListener('click', () => {
    dark.classList.add('none');
    dark.classList.remove('visible');
    light.classList.add('visible');
    light.classList.remove('none');
    container.classList.add('darkmode');
    statu.classList.add('color-white');
    TitleBot.classList.add('color-white');
});