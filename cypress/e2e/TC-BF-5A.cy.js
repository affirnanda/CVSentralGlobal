describe('TC-BF-5A', () => {

    it('User dapat submit testimonial', () => {

        cy.visit('/');

        cy.get('#testi').scrollIntoView();

        cy.get('input[name="name"]').type('Galang');

        cy.get('select[name="rating"]').select('5');

        cy.get('textarea[name="message"]')
            .type('Pelayanan sangat baik');

        cy.get('#submit-testi-btn').click();

        cy.contains('Terima kasih Telah mengisi Testimoni');
    });

});