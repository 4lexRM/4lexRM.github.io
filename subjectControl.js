var estudentsSelect = document.getElementById('students');
var activitiesSelect = document.getElementById('activities');
var evaluationsSelect = document.getElementById('evaluations');

var contStu = document.querySelector('.cont-Stud');
var contAct = document.querySelector('.cont-Act');
var contEva = document.querySelector('.cont-Eva');

estudentsSelect.addEventListener('click', (event) => { 
    contStu.style.display = 'block';
    contAct.style.display = 'none';
    contEva.style.display = 'none';
});

activitiesSelect.addEventListener('click', (event) => { 
    contStu.style.display = 'none';
    contAct.style.display = 'block';
    contEva.style.display = 'none';
});

evaluationsSelect.addEventListener('click', (event) => { 
    contStu.style.display = 'none';
    contAct.style.display = 'none';
    contEva.style.display = 'block';
});