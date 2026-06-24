describe('TC-BF-8AO', () => {

    beforeEach(() => {
        cy.visit('/testing/isi-cart');
    });

    it('TC-BF-8AO Kode Pos string', () => { 
        cy.isiCheckoutRentValid(); 
        cy.get('input[name="postal_code"]') .clear() .type('ABCDE'); 
        cy.get('button[type="submit"]').click();
        cy.contains('Silahkan input kode pos anda'); 
    });

});