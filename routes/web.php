<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnneeController;
use App\Http\Controllers\UniteValeurController;
use App\Http\Controllers\Auth\RegisteredUserController;

use App\Http\Controllers\Auth\Etudiant\EtudiantController;
use App\Http\Controllers\Auth\Enseignant\EnseignantController;
use App\Http\Controllers\Auth\Admin\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});

//route pour l'admin
Route::prefix('admin')->middleware('monGuest:admin')->group(function () {

Route::get('login', [AuthenticatedSessionController::class, 'create'])
->name('admin.login');
Route::post('login', [AuthenticatedSessionController::class, 'store']);

Route::get('register', [RegisteredUserController::class, 'showRegister'])
->name('admin.register');
Route::post('register', [RegisteredUserController::class, 'store']);
});

Route::prefix('admin')->middleware(['monAuth:admin'])->group(function () {
    Route::get('home',[RegisteredUserController::class, 'home'])->middleware(['monAuth:admin'])->name('admin.home');//verified
});

Route::get('students', [App\Http\Controllers\EtudiantController::class, 'index'])->name('students');
Route::get('students/{student}', [App\Http\Controllers\EtudiantController::class, 'show'])->name('student.show');
Route::get('students/edit/{student}', [EtudiantController::class, 'edit'])->name('student.edit');
Route::post('students/update/{student}', [EtudiantController::class, 'update'])->name('student.update');

Route::get('students/filiere/{filiere}', [App\Http\Controllers\EtudiantController::class, 'studentsByFiliere'])->name('studentsByFiliere');
Route::get('students/niveau/{niveau}', [App\Http\Controllers\EtudiantController::class, 'studentsByNiveau'])->name('studentsByNiveau');
Route::get('teachers', [App\Http\Controllers\EnseignantController::class, 'index'])->name('teachers');
// Afficher les détails d'un enseignant
Route::get('enseignant/{enseignant}', [App\Http\Controllers\EnseignantController::class, 'show'])->name('teacher.show');
Route::get('enseignant/edit/{enseignant}', [App\Http\Controllers\EnseignantController::class, 'edit'])->name('teacher.edit');


//Route pour l'enseignant
Route::prefix('enseignant')->middleware('monGuest:enseignant')->group(function () {

    Route::get('register', [EnseignantController::class, 'showRegister'])->name('enseignant.register');
    Route::post('register', [App\Http\Controllers\Auth\Enseignant\EnseignantController::class, 'register'])->name('enseignant.register');

    Route::get('login', [EnseignantController::class, 'showLogin'])->name('enseignant.login');
    // Route::post('login', [EnseignantController::class, 'login']);
});
Route::get('enseignant/home', [EnseignantController::class, 'home'])->name('enseignant.home')->middleware('monAuth:enseignant');;


// route pour l'etudiant
Route::prefix('etudiant')->middleware('monGuest:etudiant')->group(function () {

    Route::get('register', [EtudiantController::class, 'showRegister'])->name('etudiant.register');
    Route::post('register', [EtudiantController::class, 'register']);

    Route::get('login/{email?}/{code?}', [EtudiantController::class, 'showLogin'])->name('etudiant.login');
    Route::post('login', [EtudiantController::class, 'login']);
});
Route::get('etudian/logout', [EtudiantController::class, 'logout'])->name('etudiant.logout')->middleware('monAuth:etudiant');
Route::get('etudiant/home', [App\Http\Controllers\EtudiantController::class, 'home'])->name('etudiant.home')->middleware('monAuth:etudiant');

// route pour uniteValeur
Route::get('uniteValeurs', [UniteValeurController::class, 'index'])->name('uniteValeurs');

Route::prefix('uniteValeur')->group(function () {
    Route::get('create', [UniteDeValeurController::class, 'create'])->name('uniteValeur.create');
    Route::get('/{uniteDeValeur}', [uniteValeurController::class, 'show'])->name('uniteValeur.show');
    Route::get('/{uniteDeValeur}/edit', [uniteValeurController::class, 'edit'])->name('uniteValeur.edit');
    Route::put('/{uniteDeValeur}', [uniteValeurController::class, 'update'])->name('uniteValeur.update');
    Route::delete('/{uniteDeValeur}', [uniteValeurController::class, 'destroy'])->name('uniteValeur.destroy');


});



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


Route::post('annee/set-active',[AnneeController::class, 'setActive'])->name('annee.setActive');
