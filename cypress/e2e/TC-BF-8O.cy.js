describe('TC-BF-8O', () => {

    beforeEach(() => {
        cy.visit('/testing/fill-cart');
    });

    it('Ditolak', () => {

        cy.isiCheckoutValid();

        cy.get('input[name="email"]').clear();


        cy.get('#province').select('JAWA TIMUR');

        cy.wait(2000);

        cy.get('#city').select('KAB. SIDOARJO');

        cy.wait(2000);

        cy.get('#district').select('Gedangan');

        cy.get('input[name="payment_method_id"]')
            .first()
            .check({ force: true });

        cy.get('button[type="submit"]')
            .click();

        cy.contains('Silahkan input email anda')
            .should('exist');
    });

});