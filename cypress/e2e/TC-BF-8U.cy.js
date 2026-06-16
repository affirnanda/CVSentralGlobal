describe('TC-BF-8U', () => {

    beforeEach(() => {
        cy.visit('/testing/fill-cart');
    });

    it('ditolak', () => {

        cy.isiCheckoutValid();

        cy.get('#province').select('JAWA TIMUR');

        cy.wait(2000);

        cy.get('#city').select('KAB. SIDOARJO');

        cy.wait(2000);

        cy.get('#district').select('Gedangan');

        cy.get('button[type="submit"]')
            .click();

        cy.contains('Silahkan pilih metode pembayaran anda')
            .should('exist');
    });

});