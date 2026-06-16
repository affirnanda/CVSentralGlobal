describe('TC-BF-8I', () => {

    beforeEach(() => {
        cy.visit('/testing/fill-cart');
    });

    it('Muncul error', () => {

        cy.isiCheckoutValid();

        cy.get('input[name="phone"]').clear();

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

        cy.contains('Silahkan input nomor whatsapp anda')
            .should('exist');
    });

});