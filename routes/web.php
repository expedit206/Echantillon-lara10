<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnneeController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\Auth\Etudiant\EtudiantController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\GraphiqueController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UniteValeurController;
use App\Http\Controllers\SpecialiteController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
})->middleware('monGuest');


//authentification de tous les utilisateurs
Route::get('login', [AuthenticatedSessionController::class, 'create'])
->name('login')->middleware('monGuest');

Route::post('login', [AuthenticatedSessionController::class, 'store']);


Route::get('graphique', [GraphiqueController::class, 'index'])->name('graphique');
Route::get('NoteGraphique/{annee_id}', [GraphiqueController::class, 'note'])->name('NoteGraphique');

Route::prefix('admin')->middleware('monAuth:admin')->group(function () {
Route::get('board', [AppController::class, 'dashboard'])->name('dashboard')->middleware('admin');
Route::delete('destroy', [AuthenticatedSessionController::class, 'destroy'])
->name('admin.destroy');
});

//route pour l'admin
Route::prefix('admin')->group(function () {

// Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('admin.login')->middleware('monGuest:admin','monGuest:enseignant');
Route::get('logout', [AuthenticatedSessionController::class, 'logout'])
->name('admin.logout');
Route::get('{admin}', [AdminController::class, 'show'])
->name('admin.show');
// Route::post('login', [AuthenticatedSessionController::class, 'store']);

Route::get('register', [RegisteredUserController::class, 'showRegister'])
->name('admin.register');
Route::post('register', [RegisteredUserController::class, 'store']);
});

// routes/web.php
Route::put('/password/update', [PasswordController::class, 'updatePassword'])->name('password.update');
Route::get('/password/edit', [PasswordController::class, 'editPassword'])->name('password.edit');

// Route::prefix('admin')->middleware(['monAuth:admin'])->group(function () {
//     Route::get('home',[RegisteredUserController::class, 'home'])->middleware(['monAuth:admin'])->name('admin.home');//verified
// });

Route::get('students', [App\Http\Controllers\EtudiantController::class, 'index'])->name('students')->middleware('monAuth');
Route::post('studentsP', [App\Http\Controllers\EtudiantController::class, 'index'])->middleware('monAuth');
Route::get('students/{student}', [App\Http\Controllers\EtudiantController::class, 'show'])->name('student.show')->middleware('monAuth');
Route::get('students/edit/{student}', [EtudiantController::class, 'edit'])->name('student.edit')->middleware('monAuth');
Route::post('students/update/{student}', [EtudiantController::class, 'update'])->name('student.update')->middleware('monAuth');

Route::get('students/filiere/{filiere}', [App\Http\Controllers\EtudiantController::class, 'studentsByFiliere'])->name('studentsByFiliere')->middleware('monAuth');
Route::get('students/niveau/{niveau}', [App\Http\Controllers\EtudiantController::class, 'studentsByNiveau'])->name('studentsByNiveau')->middleware('monAuth');

//route concernant l'enseignant
Route::get('enseignant/register', [App\Http\Controllers\Auth\enseignant\EnseignantController::class, 'create'])->name('enseignant.register');
// Route::post('register', [App\Http\Controllers\Auth\EnseignantController::class, 'create'])->name('enseignant.register');
// Route::post('teachersP', [App\Http\Controllers\EnseignantController::class, 'index'])->name('enseignant.register');

Route::post('teachersP', [App\Http\Controllers\EnseignantController::class, 'index'])->name('teachers')->middleware('monAuth');
Route::get('teachers', [App\Http\Controllers\EnseignantController::class, 'index'])->name('teachers')->middleware('monAuth');


Route::post('register', [EnseignantController::class, 'store']);
Route::get('enseignant/{enseignant}', [App\Http\Controllers\EnseignantController::class, 'show'])->name('teacher.show')->middleware('monAuth');
Route::get('enseignant/edit/{enseignant}', [App\Http\Controllers\EnseignantController::class, 'edit'])->name('teacher.edit')->middleware('monAuth');


Route::get('/enseignants/logout', [\App\Http\Controllers\Auth\Enseignant\EnseignantController::class, 'logout'])->name('enseignant.logout')->middleware('monAuth');

Route::get('enseignants/dashboard', [EnseignantController::class, 'dashboard'])->name('enseignant.dashboard')->middleware('monAuth');

Route::resource('enseignants', \App\Http\Controllers\Auth\Enseignant\EnseignantController::class);

Route::get('/assigner-matiere', [EnseignantController::class, 'assignMatiere'])->name('assigner-matiere.create')->middleware('monAuth');
Route::post('/assigner-matiere', [EnseignantController::class, 'storeAssignMatiere'])->name('assigner-matiere.store')->middleware('monAuth');
// routes/web.php


Route::get('/cours/{uniteValeur}/graphique', [EnseignantController::class, 'graphique'])->name('coursGraphique')->middleware('monAuth');



// route pour l'etudiant
Route::get('register', [EtudiantController::class, 'showRegister'])->name('etudiant.register')->middleware('monAuth:admin');
Route::post('register', [EtudiantController::class, 'register']);
Route::prefix('etudiant')->middleware('monGuest:etudiant')->group(function () {


    // Route::get('login/{email?}/{code?}', [EtudiantController::class, 'showLogin'])->name('etudiant.login');
    // Route::post('login', [EtudiantController::class, 'login']);
});
Route::get('etudian/logout', [EtudiantController::class, 'logout'])->name('etudiant.logout')->middleware('monAuth:etudiant')->middleware('monAuth');
Route::get('etudiant/home', [App\Http\Controllers\EtudiantController::class, 'home'])->name('etudiant.home')->middleware('monAuth');

// route pour uniteValeur
Route::resource('uniteValeur', UniteValeurController::class);

// route pour note

Route::get('/notes/show', [NoteController::class, 'index'])->name('notes.index')->middleware('monAuth');
// Affiche le formulaire d'attribution des notesb
Route::get('/notes/assign', [NoteController::class, 'create'])->name('notes.create')->middleware('monAuth');

Route::get('/notes/store', [NoteController::class, 'store'])->name('notes.store')->middleware('monAuth');

// Traite la soumission du formulaire d'attribution des notes
Route::post('/notes', [NoteController::class, 'store'])->name('notes.store')->middleware('monAuth');


// route pour specialite

Route::get('/specialite/select', [SpecialiteController::class, 'selectUnite'])->name('specialite.selectUnite')->middleware('monAuth');


Route::get('/specialite/{specialite}/assign-unite', [SpecialiteController::class, 'showAssignUnite'])->name('specialite.showAssignUnite')->middleware('monAuth');
Route::post('/specialite/{specialite}/assign-unite', [SpecialiteController::class, 'assignUnite'])->name('specialite.assignUnite')->middleware('monAuth');

//breeze


// use App\Http\Controllers\ProfileController;
// use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';


Route::get('annee/set-active',[AnneeController::class, 'setActive'])->name('annee.setActive');


// Route pour obtenir les semestres en fonction de l'année
Route::get('/semestres/{annee}', [NoteController::class, 'getSemestres'])->name('getSemestres');

// Route pour obtenir les spécialités en fonction du niveau
Route::get('/specialites/{niveau}', [NoteController::class, 'getSpecialites'])->name('getSpecialites');

Route::get('/matieresBySpecialite/{semestre}/{specialite}', [NoteController::class, 'getMatieresBySpecialite'])->name('getMatieresBySpecialite');

Route::get('/matieresBySemestre/{specialite}/{semestre}', [NoteController::class, 'getMatieresBySemestre'])->name('getMatieresBySemestre');

Route::get('/specialites/{niveau}/{filiere}', [UniteValeurController::class, 'getSpecialites'])->name('getMatieresBySpecialiteNiveau');

Route::get('/filieres/{niveau}', [UniteValeurController::class, 'getFilieres'])->name('getFiliereByNiveau');


Route::get('/releve/{etudiant}/{annee}', [NoteController::class, 'showReleveDeNotes'])->name('releve.show')->middleware('monAuth');


// Route pour récupérer les matières par niveau, filière et spécialité
Route::get('/matieres/{niveauId}/{filiereId}/{specialiteId}', [UniteValeurController::class, 'getMatieres']);
