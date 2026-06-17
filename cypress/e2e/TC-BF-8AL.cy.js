describe('TC-BF-8AL', () => {

    beforeEach(() => {
        cy.visit('/testing/isi-cart');
    });

    it('TC-BF-8AL Kota kosong', () => { 
        cy.isiCheckoutRentValid(); 
        cy.get('#city').select(''); 
        cy.get('button[type="submit"]').click(); 
        cy.contains('Silahkan pilih kota anda'); 
    });

});