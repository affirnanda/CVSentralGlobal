describe('TC-BF-8AA', () => {

    beforeEach(() => {
        cy.visit('/testing/isi-cart');
    });

    it('TC-BF-8AA Nomor WA 13 digit diterima', () => { 
        cy.isiCheckoutRentValid(); 
        cy.get('input[name="phone"]') .clear() .type('1234567890123'); 
        cy.get('button[type="submit"]').click(); 
        cy.url().should('include', '/invoice/'); 
    });

});