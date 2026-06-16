describe('TC-BF-5C', () => {

    it('Nama > 100 karakter ditolak', () => {

        cy.visit('/');

        cy.get('#testi').scrollIntoView();

        cy.get('input[name="name"]')
            .invoke('val', 'A'.repeat(101))
            .trigger('input');

        cy.get('select[name="rating"]').select('5');

        cy.get('textarea[name="message"]')
            .type('Testimoni');

        cy.get('#submit-testi-btn').click();

        cy.contains('Penulisan nama terlalu panjang');
    });

});