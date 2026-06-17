describe('TC-BF-8AR', () => {

    beforeEach(() => {
        cy.visit('/testing/isi-cart');
    });

    it('TC-BF-8AR Tanggal akhir kosong', () => { 
        cy.isiCheckoutRentValid(); 
        cy.get('input[name="rent_end"]').clear(); 
        cy.get('button[type="submit"]').click(); 
        cy.contains('Silahkan pilih tanggal akhir sewa anda'); 
    });

});