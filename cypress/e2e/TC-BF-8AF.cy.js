describe('TC-BF-8AF', () => {

    beforeEach(() => {
        cy.visit('/testing/isi-cart');
    });

    it('TC-BF-8AF Alamat 201 karakter ditolak', () => { 
        cy.isiCheckoutRentValid(); 
        cy.get('input[name="address"]') .clear() .type('A'.repeat(201)); 
        cy.get('button[type="submit"]').click(); 
        cy.contains('Input alamat terlalu panjang'); 
    });

});