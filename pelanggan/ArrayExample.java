public class ArrayExample {
    public static void main(String[] args) {
        // Membuat array
        int[] myArray = { 10, 20, 30, 40, 50 };

     // Mendapatkan referensi objek dari elemen ke-2
        int index = 1; // Indeks dimulai dari 0
        int elementAtIndexTwo = myArray[index];

        // Mendapatkan "alamat" referensi objek
        int[] referenceToArray = myArray;

        // Menampilkan nilai dari elemen ke-2
        System.out.println("Nilai elemen ke-" + (index + 1) + ": " + elementAtIndexTwo);

        // Menampilkan nilai dari elemen ke-2 melalui referensi objek
        System.out.println("Nilai elemen ke-" + (index + 1) + " melalui referensi objek: " + referenceToArray[index]);

        // Manipulasi nilai elemen langsung melalui referensi objek
        referenceToArray[index] = 99;

        // Menampilkan nilai elemen ke-2 setelah dimanipulasi
        System.out.println("Nilai elemen ke-" + (index + 1) + " setelah dimanipulasi: " + myArray[index]);
    }

}
