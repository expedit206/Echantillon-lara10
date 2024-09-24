<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AppController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnneeController;

use App\Http\Controllers\GraphiqueController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\UniteValeurController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\Etudiant\EtudiantController;
use App\Http\Controllers\Auth\Admin\AuthenticatedSessionController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});






Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->middleware('monAuth:admin','monAuth:enseignant')->group(function () {

Route::get('board', [AppController::class, 'dashboard'])->name('dashboard');
});
Route::get('graphique', [GraphiqueController::class, 'index'])->name('graphique');
Route::get('NoteGraphique/{annee_id}', [GraphiqueController::class, 'note'])->name('NoteGraphique');

//route pour l'admin
Route::prefix('admin')->middleware('monGuest:admin')->group(function () {

// Route::get(' ', [AuthenticatedSessionController::class, 'create'])
// ->name('admin.login');
// Route::post('login', [AuthenticatedSessionController::class, 'store']);

Route::get('register', [RegisteredUserController::class, 'showRegister'])
->name('admin.register');
Route::post('register', [RegisteredUserController::class, 'store']);
});

// Route::prefix('admin')->middleware(['monAuth:admin'])->group(function () {
//     Route::get('home',[RegisteredUserController::class, 'home'])->middleware(['monAuth:admin'])->name('admin.home');//verified
// });

Route::get('students', [App\Http\Controllers\EtudiantController::class, 'index'])->name('students');
Route::get('students/{student}', [App\Http\Controllers\EtudiantController::class, 'show'])->name('student.show');
Route::get('students/edit/{student}', [EtudiantController::class, 'edit'])->name('student.edit');
Route::post('students/update/{student}', [EtudiantController::class, 'update'])->name('student.update');

Route::get('students/filiere/{filiere}', [App\Http\Controllers\EtudiantController::class, 'studentsByFiliere'])->name('studentsByFiliere');
Route::get('students/niveau/{niveau}', [App\Http\Controllers\EtudiantController::class, 'studentsByNiveau'])->name('studentsByNiveau');

//route concernant l'enseignant
Route::get('teachers', [App\Http\Controllers\EnseignantController::class, 'index'])->name('teachers');

Route::get('enseignant/{enseignant}', [App\Http\Controllers\EnseignantController::class, 'show'])->name('teacher.show');
Route::get('enseignant/edit/{enseignant}', [App\Http\Controllers\EnseignantController::class, 'edit'])->name('teacher.edit');


Route::get('enseignants/dashboard', [App\Http\Controllers\EnseignantController::class, 'dashboard'])->name('enseignant.dashboard')->middleware('monAuth:enseignant');

Route::resource('enseignants', \App\Http\Controllers\Auth\Enseignant\EnseignantController::class);



// route pour l'etudiant
Route::prefix('etudiant')->middleware('monGuest:etudiant')->group(function () {

    Route::get('register', [EtudiantController::class, 'showRegister'])->name('etudiant.register');
    Route::post('register', [EtudiantController::class, 'register']);

    Route::get('login/{email?}/{password?}', [EtudiantController::class, 'showLogin'])->name('etudiant.login');
    Route::post('login', [EtudiantController::class, 'login'])->name('etudiant.loginStore');
});
Route::get('etudian/logout', [EtudiantController::class, 'logout'])->name('etudiant.logout')->middleware('monAuth:etudiant');
Route::get('etudiant/home', [App\Http\Controllers\EtudiantController::class, 'home'])->name('etudiant.home')->middleware('monAuth:etudiant');

// route pour uniteValeur
Route::resource('uniteValeur', UniteValeurController::class);

// route pour note

Route::get('/notes/show', [NoteController::class, 'index'])->name('notes.index');
Route::get('/notes/create', [NoteController::class, 'create'])->name('notes.create');
// Affiche le formulaire d'attribution des notes
Route::get('/notes/assign', [NoteController::class, 'create'])->name('notes.create');

// Traite la soumission du formulaire d'attribution des notes
Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');


Route::post('annee/set-active',[AnneeController::class, 'setActive'])->name('annee.setActive');


// Route pour obtenir les semestres en fonction de l'année
Route::get('/semestres/{annee}', [NoteController::class, 'getSemestres'])->name('getSemestres');

// Route pour obtenir les spécialités en fonction du niveau
Route::get('/specialites/{niveau}', [NoteController::class, 'getSpecialites'])->name('getSpecialites');

Route::get('/matieresBySpecialite/{semestre}/{specialite}', [NoteController::class, 'getMatieresBySpecialite'])->name('getMatieresBySpecialite');

Route::get('/matieresBySemestre/{specialite}/{semestre}', [NoteController::class, 'getMatieresBySemestre'])->name('getMatieresBySemestre');


Route::get('/releve/{etudiant}/{annee}', [NoteController::class, 'showReleveDeNotes'])->name('releve.show');

require __DIR__.'/auth.php';
