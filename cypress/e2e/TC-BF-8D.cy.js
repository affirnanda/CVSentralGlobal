describe('TC-BF-8D', () => {

    beforeEach(() => {
        cy.visit('/testing/fill-cart');
    });

    it('Gagal membuat invoice karena nama kosong', () => {

        cy.isiCheckoutValid();

        cy.get('input[name="full_name"]').clear();

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

        cy.contains('Silahkan input nama anda')
            .should('exist');
    });

});