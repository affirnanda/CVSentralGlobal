describe('TC-BF-8W', () => {

    beforeEach(() => {
        cy.visit('/testing/isi-cart');
    });

    it('TC-BF-8W Nama 100 karakter diterima', () => { 
        cy.isiCheckoutRentValid();

        cy.get('input[name="full_name"]') .clear() .type('A'.repeat(100));

        cy.get('button[type="submit"]').click(); 

        cy.url().should('include', '/invoice/'); 
    });
});