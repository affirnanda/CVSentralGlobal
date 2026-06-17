describe('TC-BF-8AG', () => {

    beforeEach(() => {
        cy.visit('/testing/isi-cart');
    });

    it('TC-BF-8AG Alamat kosong', () => { 
        cy.isiCheckoutRentValid(); 
        cy.get('input[name="address"]').clear(); 
        cy.get('button[type="submit"]').click(); 
        cy.contains('Silahkan input alamat pengiriman anda'); 
    });

});