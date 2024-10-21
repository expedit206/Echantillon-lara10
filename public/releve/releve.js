document.getElementById('printButton').addEventListener('click', function() {
    // alert('kkj')
    var printContents = document.getElementById('releve').innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    // location.reload(); // Recharge la page pour restaurer la structure d'origine
});