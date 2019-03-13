function calculateAmount() {
    const dateFin = new Date($('#dateDebut').val().replace(/(\d+)\/(\d+)\/(\d{4})/ , '$3-$2-$1'));
    const dateDebut = new Date($('#dateFin').val().replace(/(\d+)\/(\d+)\/(\d{4})/ , '$3-$2-$1'));

    if (dateDebut && dateFin && dateDebut < dateFin){
        const DAY_TIME = 24 * 60 * 60 * 1000;

        const interval = dateFin.getTime() - dateDebut.getTime();
        const days = interval / DAY_TIME;

        $('#dureeStage').text(days);
    }
}
