describe('TC-BF-5E', () => {

    it('Pesan 200 karakter diterima', () => {

        cy.visit('/');

        cy.get('#testi').scrollIntoView();

        cy.get('input[name="name"]').type('Galang');

        cy.get('select[name="rating"]').select('5');

        cy.get('textarea[name="message"]')
            .type('A'.repeat(200));

        cy.get('#submit-testi-btn').click();

        cy.contains('Terima kasih Telah mengisi Testimoni');
    });

});