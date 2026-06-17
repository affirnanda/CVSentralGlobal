describe('TC-BF-8H', () => {

    beforeEach(() => {
        cy.visit('/testing/isi-cart');
    });

    it('TC-BF-8AH Keranjang kosong', () => { 
        cy.visit('/testing/clear-cart'); 
        cy.visit('/checkout/rent', { failOnStatusCode: false }); 
        cy.contains('Keranjang kosong'); 
    });

});