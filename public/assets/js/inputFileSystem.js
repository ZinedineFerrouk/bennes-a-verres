// Variables
var dropArea = document.getElementById('js_drag-area');
var dragText = document.getElementById('js_drag-text');
var input = document.getElementById('registration_form_kbis');
var errorList = document.querySelector('.notice-error');
var file;

// Quand l'input change d'état
input.addEventListener("change", function(){
  // Affiche le nom du fichier
  file = this.files[0];
  dragText.textContent = file.name;
});

// Quand l'utilisateur glisse le fichier sur DropArea
dropArea.addEventListener("dragover", (event)=>{
  // Le contenu du texte devient...
  event.preventDefault();
  dragText.textContent = "Lâcher pour importer le fichier";
});

// Quand l'utilisateur glisse le fichier en dehors de DropArea
dropArea.addEventListener("dragleave", ()=>{
  // Le contenu du texte devient...
  dragText.innerHTML = "Glisser & Déposer pour importer un fichier<span>OU</span>Cliquer pour parcourir";
});

// Quand l'utilisateur lâche le fichier dans DropArea
dropArea.addEventListener("drop", (event)=>{
  // Affiche le nom du fichier
  event.preventDefault();
  file = event.dataTransfer.files[0];
  dragText.innerHTML = file.name;
});