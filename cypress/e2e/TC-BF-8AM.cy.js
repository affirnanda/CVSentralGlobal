describe('TC-BF-8AM', () => {

    beforeEach(() => {
        cy.visit('/testing/isi-cart');
    });

    it('TC-BF-8AM Kecamatan kosong', () => { 
        cy.isiCheckoutRentValid(); 
        cy.get('#district').select(''); 
        cy.get('button[type="submit"]').click(); 
        cy.contains('Silahkan pilih kecamatan anda'); 
    });

});