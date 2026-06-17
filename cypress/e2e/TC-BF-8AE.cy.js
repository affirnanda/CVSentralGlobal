describe('TC-BF-8AE', () => {

    beforeEach(() => {
        cy.visit('/testing/isi-cart');
    });

   it('TC-BF-8AE Alamat 200 karakter diterima', () => { 
    cy.isiCheckoutRentValid(); 
    cy.get('input[name="address"]') .clear() .type('A'.repeat(200)); 
    cy.get('button[type="submit"]').click(); 
    cy.url().should('include', '/invoice/'); 
    });

});