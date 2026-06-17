describe('TC-BF-8AI', () => {

    beforeEach(() => {
        cy.visit('/testing/isi-cart');
    });

    it('TC-BF-8AI Email salah', () => { 
        cy.isiCheckoutRentValid(); 
        cy.get('input[name="email"]') .clear() .type('galang'); 
        cy.get('button[type="submit"]').click(); 
        cy.contains('Format email anda salah'); 
    });

});