describe('TC-BF-5F', () => {

    it('Pesan > 200 karakter ditolak', () => {

        cy.visit('/');

        cy.get('#testi').scrollIntoView();

        cy.get('input[name="name"]').type('Galang');

        cy.get('select[name="rating"]').select('5');

        cy.get('textarea[name="message"]')
            .invoke('val', 'A'.repeat(201))
            .trigger('input');

        cy.get('#submit-testi-btn').click();

        cy.contains('Pesan testimoni terlalu panjang');
    });

});