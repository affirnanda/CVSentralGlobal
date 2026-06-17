describe('TC-BF-8AP', () => {

    beforeEach(() => {
        cy.visit('/testing/isi-cart');
    });

    it('TC-BF-8AP Metode pembayaran kosong', () => { 
        cy.isiCheckoutRentValid(); 
        cy.get('input[name="payment_method_id"]') .uncheck({ force: true }); 
        cy.get('button[type="submit"]').click(); 
        cy.contains('Silahkan pilih metode pembayaran anda'); 
    });

});