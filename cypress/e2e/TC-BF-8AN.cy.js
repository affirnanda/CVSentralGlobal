describe('TC-BF-8AN', () => {

    beforeEach(() => {
        cy.visit('/testing/isi-cart');
    });

    it('TC-BF-8AN Kode Pos kosong', () => { 
        cy.isiCheckoutRentValid(); 
        cy.get('input[name="postal_code"]').clear(); 
        cy.get('button[type="submit"]').click(); 
        cy.contains('Silahkan input kode pos anda'); 
    });

});