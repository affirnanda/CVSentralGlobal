describe('TC-BF-5D', () => {

    it('Nama kosong ditolak', () => {

        cy.visit('/');

        cy.get('#testi').scrollIntoView();

        cy.get('select[name="rating"]').select('5');

        cy.get('textarea[name="message"]')
            .type('Testimoni');

        cy.get('#submit-testi-btn').click();

        cy.contains('Silahkan isi nama anda');
    });

});