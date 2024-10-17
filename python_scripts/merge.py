# python_scripts/merge.py
import sys
from docx import Document

def merge_documents(file_list, output_file):
    merged_document = Document()

    for file in file_list:
        doc = Document(file)
        for element in doc.element.body:
            merged_document.element.body.append(element)

    merged_document.save(output_file)

if __name__ == "__main__":
    # Ambil daftar file dan file output dari argumen
    file_list = sys.argv[1:-1]
    output_file = sys.argv[-1]

    # Gabungkan dokumen-dokumen tersebut
    merge_documents(file_list, output_file)
