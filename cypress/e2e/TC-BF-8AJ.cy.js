describe('TC-BF-8AJ', () => {

    beforeEach(() => {
        cy.visit('/testing/isi-cart');
    });

    it('TC-BF-8AJ Email kosong', () => { 
        cy.isiCheckoutRentValid(); 
        cy.get('input[name="email"]').clear(); 
        cy.get('button[type="submit"]').click(); 
        cy.contains('Silahkan input email anda'); 
    });

});