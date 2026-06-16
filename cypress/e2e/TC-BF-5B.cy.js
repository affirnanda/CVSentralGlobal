describe('TC-BF-5B', () => {

    it('Nama 100 karakter diterima', () => {

        cy.visit('/');

        cy.get('#testi').scrollIntoView();

        cy.get('input[name="name"]')
            .type('A'.repeat(100));

        cy.get('select[name="rating"]').select('5');

        cy.get('textarea[name="message"]')
            .type('Testimoni');

        cy.get('#submit-testi-btn').click();

        cy.contains('Terima kasih Telah mengisi Testimoni');
    });

});