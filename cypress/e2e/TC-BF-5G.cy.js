describe('TC-BF-5G.js', () => {

    it('Pesan kosong ditolak', () => {

        cy.visit('/');

        cy.get('#testi').scrollIntoView();

        cy.get('input[name="name"]').type('Galang');

        cy.get('select[name="rating"]').select('5');

        cy.get('#submit-testi-btn').click();

        cy.contains('Silahkan isi pesan testimoni');
    });

});