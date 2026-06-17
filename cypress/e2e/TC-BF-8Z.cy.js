describe('TC-BF-8Z', () => {

    beforeEach(() => {
        cy.visit('/testing/isi-cart');
    });

    it('TC-BF-8Z Nomor WA 9 digit diterima', () => { 
        cy.isiCheckoutRentValid(); 
        cy.get('input[name="phone"]') .clear() .type('123456789'); 
        cy.get('button[type="submit"]').click(); 
        cy.url().should('include', '/invoice/'); 
    });

});